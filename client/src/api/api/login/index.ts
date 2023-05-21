import { User } from "@/types/user";

export type PostRequest = {};
export type PostResponse = {
  message: string;
  data: User;
};

export interface Methods {
  post: {
    reqBody: PostRequest;
    resBody: PostResponse;
  };
}
