import { Quiz } from "@/types/quiz";

export type GetResponse = {
  message: string;
  data: Quiz;
};

export interface Methods {
  get: {
    reqHeaders: {
      Authorization: string;
    };

    resBody: GetResponse;
  };
}
