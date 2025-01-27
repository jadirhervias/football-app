export const getCookie = (name: string): string | null => {
  if (typeof window === 'undefined') {
    return null;
  }

  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);

  if (parts.length === 2) {
    return decodeURIComponent(parts.pop()?.split(';').shift() ?? '');
  }

  return null;
}

export const setCookie = (
  name: string,
  value: string,
  days: number = 7, // Default cookie expiration is 7 days
  path: string = '/'
) => {
  if (typeof window === 'undefined') {
    return;
  }

  const expirationDate = new Date();
  expirationDate.setTime(expirationDate.getTime() + (days * 24 * 60 * 60 * 1000));

  document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expirationDate.toUTCString()}; path=${path}; Secure; SameSite=Strict`;
}

export const clearCookies = (...cookieNames: string[]) =>  {
  if (typeof window === 'undefined') {
    return;
  }

  cookieNames.forEach(cookieName => {
    document.cookie = `${cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/`;
  });
}
