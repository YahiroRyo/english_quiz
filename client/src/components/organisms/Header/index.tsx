import { NavigationElement } from "@/components/molecures/NavigationBar/types";
import { NavigationBar } from "@/components/molecures/NavigationBar";
import { ROUTE_PATHNAME } from "@/constants/route";
import styles from "./index.module.scss";
import { useRouter } from "next/router";
import { useAuth } from "@/hooks/user/useAuth";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faBars,
  faBook,
  faRightFromBracket,
  faRightToBracket,
  faUserPlus,
  faXmark,
} from "@fortawesome/free-solid-svg-icons";

type Props = {
  isOpeningMenu: boolean;
  handleClickToggleMenuButton: () => void;
};

export const Header = ({
  isOpeningMenu,
  handleClickToggleMenuButton,
}: Props) => {
  const router = useRouter();
  const [user] = useAuth();

  const unLoggedInNavigationElementList: NavigationElement[] = [
    {
      pathname: ROUTE_PATHNAME.REGISTER,
      content: (
        <div className={styles.navigationElement}>
          <FontAwesomeIcon icon={faUserPlus} />
          {"登録"}
        </div>
      ),
    },
    {
      pathname: ROUTE_PATHNAME.LOGIN,
      content: (
        <div className={styles.navigationElement}>
          <FontAwesomeIcon icon={faRightToBracket} />
          {"ログイン"}
        </div>
      ),
    },
  ];

  const loggedInNavigationElementList: NavigationElement[] = [
    {
      pathname: ROUTE_PATHNAME.TOP,
      content: (
        <div className={styles.navigationElement}>
          <FontAwesomeIcon icon={faBook} />
          {"問題を解く"}
        </div>
      ),
    },
    {
      pathname: ROUTE_PATHNAME.LOGOUT,
      content: (
        <div className={styles.navigationElement}>
          <FontAwesomeIcon icon={faRightFromBracket} />
          {"ログアウト"}
        </div>
      ),
    },
  ];

  if (user) {
    return (
      <header className={styles.header}>
        <button
          onClick={handleClickToggleMenuButton}
          className={styles.toggleMenuButton}
        >
          <FontAwesomeIcon icon={isOpeningMenu ? faXmark : faBars} />
        </button>
        <NavigationBar
          currentPathname={router.pathname}
          navigationElementList={loggedInNavigationElementList}
        />
      </header>
    );
  }

  return (
    <header className={styles.header}>
      <NavigationBar
        currentPathname={router.pathname}
        navigationElementList={unLoggedInNavigationElementList}
      />
    </header>
  );
};
