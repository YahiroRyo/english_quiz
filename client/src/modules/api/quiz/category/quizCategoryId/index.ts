import { GetResponse } from "@/api/api/quiz/categoryList/_quizCategoryId@number";
import { apiClient, handleSWRResponse, initRetryCount } from "../../../client";
import useSWR, { KeyedMutator } from "swr";

export const apiQuizCategory = (
  quizCategoryId: number,
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
    `/api/quiz/categoryList/${quizCategoryId}`,
    () => {
      apiClient().sanctum.csrf_cookie.$get();
      return apiClient()
        .api.quiz.categoryList._quizCategoryId(quizCategoryId)
        .$get();
    }
  );

  return {
    ...handleSWRResponse(
      `/api/quiz/categoryList/${quizCategoryId}`,
      data,
      error,
      isLoading
    ),
    mutate,
    initRetryCount: () => {
      initRetryCount(`/api/quiz/categoryList/${quizCategoryId}`);
    },
  };
};
