import { apiClient } from "../../client";

export const apiQuizCategoryList = (token: string) => {
  apiClient().sanctum.csrf_cookie.$get();
  return apiClient().api.quiz.categoryList.$get({
    headers: { Authorization: `Bearer ${token}` },
  });
};
