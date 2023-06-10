import { QuizCategory } from "@/types/quiz";

export type GetResponse = {
  message: string;
  data: QuizCategory[];
};

export interface Methods {
  get: {
    resBody: GetResponse;
  };
}
