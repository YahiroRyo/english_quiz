import aspida from "@aspida/axios";
import axios, { type AxiosRequestConfig } from "axios";
import { type ApiInstance, default as api } from "@/api/$api";
import { AxiosError } from "axios";
import { ErrorResponse, errorDictToString } from "@/types/response";
import { ERROR_MESSAGE } from "@/constants/api";

const retryCount: { [key: string]: number } = {};

// eslint-disable-next-line
export const apiClient = (config?: AxiosRequestConfig<any> | undefined) => {
  return api(
    aspida(
      axios.create(),
      Object.assign(
        {
          baseURL: process.env.NEXT_PUBLIC_API_URL,
          paramsSerializer: {
            indexes: false,
          },
          withCredentials: true,
        },
        config
      )
    )
  ) as ApiInstance;
};

export const handleSWRResponse = (
  key: string,
  data: any,
  error: any,
  isLoading: boolean
) => {
  if (error && error instanceof AxiosError) {
    const responseData = error.response?.data as ErrorResponse;
    const status = error.response?.status!;
    incrementRetryCount(key);

    if (status === 401 || status === 403) {
      return {
        data: undefined,
        error: responseData.message,
        isLoading,
        status,
        retryCount: getRetryCount(key),
      };
    }

    if (status === 400) {
      return {
        data: undefined,
        error: errorDictToString(responseData.data),
        isLoading,
        status,
        retryCount: getRetryCount(key),
      };
    }

    return {
      data: undefined,
      error: responseData.message,
      isLoading,
      status,
      retryCount: getRetryCount(key),
    };
  }

  if (error) {
    incrementRetryCount(key);

    return {
      data: undefined,
      error: ERROR_MESSAGE.UNKNOWN_ERROR,
      isLoading,
      status: 200,
      retryCount: getRetryCount(key),
    };
  }

  return {
    error: undefined,
    data,
    isLoading,
    status: 200,
    retryCount: getRetryCount(key),
  };
};

export const initRetryCount = (key: string) => {
  retryCount[key] = 0;
};

const incrementRetryCount = (key: string) => {
  if (retryCount[key]) {
    retryCount[key]++;
    return;
  }
  retryCount[key] = 1;
};

const getRetryCount = (key: string) => {
  return retryCount[key] ?? 0;
};
