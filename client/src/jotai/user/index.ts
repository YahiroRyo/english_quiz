import { User } from "@/types/user";
import { atomWithStorage } from "jotai/utils";

export const userAtom = atomWithStorage<User | undefined>("user", undefined);
