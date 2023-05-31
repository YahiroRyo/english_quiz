import { apiClient } from "../client";

export const apiCreateQuizList = (quizCategoryId: number, token: string) => {
  apiClient().sanctum.csrf_cookie.$get();
  return apiClient().api.quiz.$post({
    body: { quizCategoryId },
    headers: { Authorization: `Bearer ${token}` },
  });
};
