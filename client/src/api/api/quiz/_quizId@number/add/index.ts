import { Quiz } from "@/types/quiz";

export type PostRequest = {
  message: string;
};

export type PostResponse = {
  message: string;
  data: Quiz;
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
