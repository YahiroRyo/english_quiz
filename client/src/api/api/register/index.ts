import { User } from "@/types/user";

export type PostRequest = {
  username: string;
  password: string;
  personality: string;
  name: string;
  icon: File;
};
export type PostResponse = {
  message: string;
  data: User;
};

export interface Methods {
  post: {
    reqBody: PostRequest;
    resBody: PostResponse;

    reqFormat: FormData;
  };
}
