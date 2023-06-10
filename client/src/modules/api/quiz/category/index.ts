import { apiClient } from "../../client";

export const apiQuizCategoryList = async () => {
  await apiClient().sanctum.csrf_cookie.$get();
  return apiClient().api.quiz.categoryList.$get();
};
