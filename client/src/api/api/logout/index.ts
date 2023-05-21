import { User } from "@/types/user";

export type PostResponse = {
  message: string;
  data: User;
};

export interface Methods {
  post: {
    resBody: PostResponse;
  };
}
