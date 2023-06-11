import { Header } from "@/components/organisms/Header";
import { QuizCategoryList } from "@/components/organisms/QuizCategoryList";
import { QuizCategory } from "@/types/quiz";
import Head from "next/head";
import styles from "./index.module.scss";
import { useState } from "react";

type Props = {
  children?: React.ReactNode;
  title: string;
  description?: string;
  quizCategoryList: QuizCategory[];
};

export const HeaderAndQuizCategoryListWithPage = ({
  children,
  title,
  description,
  quizCategoryList,
}: Props) => {
  const [isOpeningMenu, setIsOpeningMenu] = useState(false);

  return (
    <>
      <Head>
        <title>{`${title} | English Quiz`}</title>
        <meta name="description" content={description} />
      </Head>

      <Header
        isOpeningMenu={isOpeningMenu}
        handleClickToggleMenuButton={() => setIsOpeningMenu(!isOpeningMenu)}
      />
      <main className={styles.main}>
        <div
          className={`${styles.menu} ${
            isOpeningMenu ? styles.menuOpening : ""
          }`}
          onClick={() => setIsOpeningMenu(!isOpeningMenu)}
        >
          <QuizCategoryList quizCategoryList={quizCategoryList} />
        </div>
        <div className={styles.mainContents}>{children}</div>
      </main>
    </>
  );
};
