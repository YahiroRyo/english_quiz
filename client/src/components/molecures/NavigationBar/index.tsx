import { ActiveUnderlineButton } from "@/components/atoms/ActiveUnderlineButton";
import { NavigationElement } from "./types";
import { NonActiveUnderlineButton } from "@/components/atoms/NonActiveUnderlineButton";
import style from "./index.module.scss";
import Link from "next/link";

type Props = {
  currentPathname: string;
  navigationElementList: NavigationElement[];
};

export const NavigationBar = ({
  currentPathname,
  navigationElementList,
}: Props) => {
  return (
    <nav className={style.nav}>
      <>
        {navigationElementList.map((navigationElement, index) => {
          if (navigationElement.pathname === currentPathname) {
            return (
              <Link
                className={style.navLink}
                key={index}
                href={navigationElement.pathname}
              >
                <ActiveUnderlineButton>
                  {navigationElement.content}
                </ActiveUnderlineButton>
              </Link>
            );
          }

          return (
            <Link
              className={style.navLink}
              key={index}
              href={navigationElement.pathname}
            >
              <NonActiveUnderlineButton>
                {navigationElement.content}
              </NonActiveUnderlineButton>
            </Link>
          );
        })}
      </>
    </nav>
  );
};
