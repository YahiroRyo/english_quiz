import { PostRequest, PostResponse } from "@/api/api/login";
import { apiClient } from "../client";

export const apiLogin = async (request: PostRequest) => {
  apiClient().sanctum.csrf_cookie.$get();
  return apiClient().api.login.$post({ body: request });
};

export type { PostRequest, PostResponse };
