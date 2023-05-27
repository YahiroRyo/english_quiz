import { PostRequest, PostResponse } from "@/api/api/register";
import { apiClient } from "../client";

export const apiRegisterUser = async (request: PostRequest) => {
  apiClient().sanctum.csrf_cookie.$get();
  return apiClient().api.register.$post({ body: request });
};

export type { PostRequest, PostResponse };
