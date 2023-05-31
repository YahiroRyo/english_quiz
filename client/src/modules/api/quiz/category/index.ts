import { GetResponse } from "@/api/api/quiz/categoryList";
import { apiClient, handleSWRResponse, initRetryCount } from "../../client";
import useSWR, { KeyedMutator } from "swr";

export const apiQuizCategoryList = (
  token?: string
): {
  data?: GetResponse;
  error?: string;
  isLoading: boolean;
  status: number;
  retryCount: number;
  mutate: KeyedMutator<GetResponse>;
  initRetryCount: () => void;
} => {
  const { data, error, isLoading, mutate } = useSWR(
    "/api/quiz/categoryList",
    () => {
      apiClient().sanctum.csrf_cookie.$get();
      return apiClient().api.quiz.categoryList.$get({
        headers: { Authorization: `Bearer ${token}` },
      });
    }
  );

  return {
    ...handleSWRResponse("/api/quiz/categoryList", data, error, isLoading),
    mutate,
    initRetryCount: () => {
      initRetryCount("/api/quiz/categoryList");
    },
  };
};
