import { Quiz, QuizCategory } from "@/types/quiz";

export type GetRequest = {
  quizCategoryId: number;
  currentPageCount: number;
};

export type GetResponse = {
  message: string;
  data: {
    quizList: Quiz[];
    currentPageCount: number;
    maxPageCount: number;
  };
};

export type PostRequest = {
  quizCategoryId: number;
};

export type PostResponse = {
  message: string;
  data: QuizCategory[];
};

export interface Methods {
  get: {
    reqHeaders: {
      Authorization: string;
    };

    query: GetRequest;
    resBody: GetResponse;
  };

  post: {
    reqHeaders: {
      Authorization: string;
    };

    reqBody: PostRequest;
    resBody: PostResponse;
  };
}
