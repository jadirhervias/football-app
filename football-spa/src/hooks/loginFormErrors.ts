import { reactive } from 'vue';

export interface ErrorFormFields {
  email: string | null;
  password: string | null;
}

export function useLoginFormErrors() {
  return reactive<ErrorFormFields & {
    set: (key: keyof ErrorFormFields, msg: string | null) => void;
    get: (key: keyof ErrorFormFields) => string | null;
    hasError: (key: keyof ErrorFormFields) => boolean;
    hasErrors: () => boolean;
    reset: () => void;
  }>({
    email: null,
    password: null,
    set(key: keyof ErrorFormFields, msg: string | null) {
      this[key] = msg;
    },
    get(key: keyof ErrorFormFields) {
      return this[key];
    },
    hasError(key: keyof ErrorFormFields) {
      return this[key] !== null;
    },
    hasErrors() {
      return this.email !== null || this.password !== null;
    },
    reset() {
      this.email = null;
      this.password = null;
    }
  });
}
