import { NavigationElement } from "@/components/molecures/NavigationBar/types";
import { NavigationBar } from "@/components/molecures/NavigationBar";
import { ROUTE_PATHNAME } from "@/constants/route";
import style from "./index.module.scss";
import { useRouter } from "next/router";
import { useAuth } from "@/hooks/user/useAuth";

export const Header = () => {
  const router = useRouter();
  const [user] = useAuth();

  const unLoggedInNavigationElementList: NavigationElement[] = [
    {
      pathname: ROUTE_PATHNAME.REGISTER,
      content: "登録",
    },
    {
      pathname: ROUTE_PATHNAME.LOGIN,
      content: "ログイン",
    },
  ];
  const loggedInNavigationElementList: NavigationElement[] = [
    {
      pathname: ROUTE_PATHNAME.LOGOUT,
      content: "ログアウト",
    },
    {
      pathname: ROUTE_PATHNAME.TOP,
      content: "トップ",
    },
  ];

  if (user) {
    return (
      <header className={style.header}>
        <NavigationBar
          currentPathname={router.pathname}
          navigationElementList={loggedInNavigationElementList}
        />
      </header>
    );
  }

  return (
    <header className={style.header}>
      <NavigationBar
        currentPathname={router.pathname}
        navigationElementList={unLoggedInNavigationElementList}
      />
    </header>
  );
};
