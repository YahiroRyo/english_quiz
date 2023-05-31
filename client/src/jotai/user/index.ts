import { User } from "@/types/user";
import { atomWithStorage } from "jotai/utils";
import { JOTAI_KEY } from "..";

export const userAtom = atomWithStorage<User | undefined>(
  JOTAI_KEY.USER,
  undefined
);
