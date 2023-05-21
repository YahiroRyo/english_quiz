import { PostResponse } from "@/api/api/logout";
import { apiClient } from "../client";

export const apiLogout = async () => {
  apiClient().sanctum.csrf_cookie.$get();
  return apiClient().api.logout.$post();
};

export type { PostResponse };
