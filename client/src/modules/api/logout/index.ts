import { PostResponse } from "@/api/api/logout";
import { apiClient, handleSWRResponse } from "../client";
import useSWR from "swr";

export const apiLogout = async (token: string) => {
  const { data, error, isLoading } = useSWR("/api/logout", () => {
    apiClient().sanctum.csrf_cookie.$get();
    return apiClient().api.logout.$post({
      headers: { Authorization: `Bearer ${token}` },
    });
  });

  return handleSWRResponse("/api/logout", data, error, isLoading);
};

export type { PostResponse };
