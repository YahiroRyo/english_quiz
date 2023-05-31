import { ROUTE_PATHNAME } from "@/constants/route";
import { JOTAI_KEY, isReady } from "@/jotai";
import { userAtom } from "@/jotai/user";
import { useAtom } from "jotai";
import { useRouter } from "next/router";
import { useEffect } from "react";
import { useSafePush } from "../route/useSafePush";

export const useAuth = () => {
  const router = useRouter();
  const safePush = useSafePush();
  const [user, setUser] = useAtom(userAtom);

  useEffect(() => {
    const userIsEmpty = () => !user;
    const pathnameIsForUnLoggedInUser = () =>
      router.pathname === ROUTE_PATHNAME.LOGIN ||
      router.pathname === ROUTE_PATHNAME.REGISTER;
    const pathnameIsForLoggedInUser = () => !pathnameIsForUnLoggedInUser();

    if (!isReady(JOTAI_KEY.USER, user)) {
      return;
    }

    if (userIsEmpty() && pathnameIsForLoggedInUser()) {
      safePush(ROUTE_PATHNAME.LOGIN);
      return;
    }
    if (userIsEmpty() && pathnameIsForUnLoggedInUser()) {
      return;
    }

    if (pathnameIsForUnLoggedInUser()) {
      safePush(ROUTE_PATHNAME.TOP);
      return;
    }
  }, [user]);

  return [user, setUser, isReady(JOTAI_KEY.USER, user)] as const;
};
