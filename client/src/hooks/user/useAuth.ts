import { ROUTE_PATHNAME } from "@/constants/route";
import { userAtom } from "@/jotai/user";
import { useAtom } from "jotai";
import { useRouter } from "next/router";
import { useEffect } from "react";

export const useAuth = () => {
  const router = useRouter();
  const [user, setUser] = useAtom(userAtom);

  useEffect(() => {
    const userIsEmpty = () => !user;
    const pathnameIsForUnLoggedInUser = () =>
      router.pathname === ROUTE_PATHNAME.LOGIN ||
      router.pathname === ROUTE_PATHNAME.REGISTER;
    const pathnameIsForLoggedInUser = () => !pathnameIsForUnLoggedInUser();

    if (userIsEmpty() && pathnameIsForLoggedInUser()) {
      router.push(ROUTE_PATHNAME.LOGIN);
      return;
    }
    if (userIsEmpty() && pathnameIsForUnLoggedInUser()) {
      return;
    }

    if (pathnameIsForUnLoggedInUser()) {
      router.push(ROUTE_PATHNAME.TOP);
      return;
    }
  }, []);

  return [user, setUser] as const;
};
