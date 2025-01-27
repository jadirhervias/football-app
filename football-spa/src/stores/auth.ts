import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { getCookie, setCookie, clearCookies } from "@/utils/cookies.ts";

export const useAuthStore = defineStore('user', () => {
  const accessToken = ref<string | null>(getCookie('access_token') || null);
  const refreshToken = ref<string | null>(getCookie('refresh_token') || null);
  const tokensExist = computed(() => !!accessToken.value && !!refreshToken.value);

  // Save the token to the Pinia store and cookie
  const setAccessToken = (newToken: string) => {
    accessToken.value = newToken;
    setCookie('access_token', newToken, 1);
  };

  const setRefreshToken = (newToken: string) => {
    refreshToken.value = newToken;
    setCookie('refresh_token', newToken, 7);
  };

  // Clear the token (e.g., on logout)
  const clearTokens = () => {
    accessToken.value = null;
    refreshToken.value = null;
    clearCookies('access_token', 'refresh_token');
  };

  return {
    tokensExist,
    accessToken,
    refreshToken,
    setAccessToken,
    setRefreshToken,
    clearTokens,
  };
});
