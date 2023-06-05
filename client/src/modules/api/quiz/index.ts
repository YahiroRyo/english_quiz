import { GetResponse as QuizListGetResponse } from "@/api/api/quiz";
import { GetResponse as QuizGetResponse } from "@/api/api/quiz/_quizId@number";
import { apiClient, handleSWRResponse, initRetryCount } from "../client";
import { KeyedMutator } from "swr";
import useSWR from "swr";

export const apiCreateQuizList = (quizCategoryId: number, token: string) => {
  apiClient().sanctum.csrf_cookie.$get();
  return apiClient().api.quiz.$post({
    body: { quizCategoryId },
    headers: { Authorization: `Bearer ${token}` },
  });
};

export const apiQuizList = (
  quizCategoryId: number,
  currentPageCount: number,
  token: string
): {
  data?: QuizListGetResponse;
  error?: string;
  isLoading: boolean;
  status: number;
  retryCount: number;
  mutate: KeyedMutator<QuizListGetResponse>;
  initRetryCount: () => void;
} => {
  const key = `/api/quiz_GET_${quizCategoryId}_${currentPageCount}`;

  const { data, error, isLoading, mutate } = useSWR(key, () => {
    apiClient().sanctum.csrf_cookie.$get();
    return apiClient().api.quiz.$get({
      query: { quizCategoryId, currentPageCount },
      headers: { Authorization: `Bearer ${token}` },
    });
  });

  return {
    ...handleSWRResponse(key, data, error, isLoading),
    mutate,
    initRetryCount: () => {
      initRetryCount(key);
    },
  };
};

export const apiQuiz = (
  quizId: number,
  token: string
): {
  data?: QuizGetResponse;
  error?: string;
  isLoading: boolean;
  status: number;
  retryCount: number;
  mutate: KeyedMutator<QuizGetResponse>;
  initRetryCount: () => void;
} => {
  const key = `/api/quiz/${quizId}_GET_`;

  const { data, error, isLoading, mutate } = useSWR(key, () => {
    apiClient().sanctum.csrf_cookie.$get();
    return apiClient()
      .api.quiz._quizId(quizId)
      .$get({
        headers: { Authorization: `Bearer ${token}` },
      });
  });

  return {
    ...handleSWRResponse(key, data, error, isLoading),
    mutate,
    initRetryCount: () => {
      initRetryCount(key);
    },
  };
};

export const apiAddMessage = (
  quizId: number,
  message: string,
  token: string
) => {
  apiClient().sanctum.csrf_cookie.$get();
  return apiClient()
    .api.quiz._quizId(quizId)
    .add.$post({
      body: { message },
      headers: { Authorization: `Bearer ${token}` },
    });
};
