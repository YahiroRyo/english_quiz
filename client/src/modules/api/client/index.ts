import aspida from "@aspida/axios";
import axios, { type AxiosRequestConfig } from "axios";
import { type ApiInstance, default as api } from "@/api/$api";

// eslint-disable-next-line
export const apiClient = (config?: AxiosRequestConfig<any> | undefined) => {
  return api(
    aspida(
      axios.create(),
      Object.assign(
        {
          baseURL: "http://localhost:8000",
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
