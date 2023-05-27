import { User } from "@/types/user";

export type PostResponse = {
  message: string;
  data: User;
};

export interface Methods {
  post: {
    reqHeaders: {
      Authorization: string;
    };
    resBody: PostResponse;
  };
}
