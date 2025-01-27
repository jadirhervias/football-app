import {ref, type Ref} from 'vue';
import {useAuthStore} from "@/stores/auth.ts";

export async function useFetch(path: string, config?: {
  method?: string;
  body?: Record<string, unknown>;
}, useAuth?: boolean): Promise<{
  status: Ref<number | null>,
  data: Ref<Record<string, unknown>>,
  error: Ref<Record<string, unknown>>
}> {
  console.log('useAuth', useAuth);

  const status = ref<number | null>(null);
  const data = ref({});
  const error = ref({});

  let headersConfig: Record<string, string> = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  if (useAuth) {
    const authStore = useAuthStore();
    const { accessToken } = authStore;

    if (accessToken) {
      headersConfig = {
        ...headersConfig,
        Authorization: `Bearer ${accessToken}`,
      }
    }
  }

  const fetchReq: RequestInit = {
    headers: headersConfig,
    method: config?.method ?? 'GET',
    body: config?.method === 'POST' && config.body ? JSON.stringify(config.body) : null,
  }

  console.log('fetchReq', fetchReq)

  try {
    const response = await fetch(path, fetchReq);
    const resData = await response.json();

    console.log("response data", resData);

    status.value = response.status;
    data.value = resData;
  } catch (err) {
    error.value = err as Error;
  }

  return { status, data, error };
}
