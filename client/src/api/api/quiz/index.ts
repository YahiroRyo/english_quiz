import { QuizCategory } from "@/types/quiz";

export type PostRequest = {
  quizCategoryId: number;
};

export type PostResponse = {
  message: string;
  data: QuizCategory[];
};

export interface Methods {
  post: {
    reqHeaders: {
      Authorization: string;
    };

    reqBody: PostRequest;
    resBody: PostResponse;
  };
}
