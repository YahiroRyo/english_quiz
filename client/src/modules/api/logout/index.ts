import { PostResponse } from "@/api/api/logout";
import { apiClient } from "../client";

export const apiLogout = async (token: string) => {
  apiClient().sanctum.csrf_cookie.$get();
  return apiClient().api.logout.$post({
    headers: { Authorization: `Bearer ${token}` },
  });
};

export type { PostResponse };
