import { Header } from "@/components/organisms/Header";
import { QuizCategoryList } from "@/components/organisms/QuizCategoryList";
import { QuizCategory } from "@/types/quiz";
import Head from "next/head";
import styles from "./index.module.scss";

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
  return (
    <>
      <Head>
        <title>{`${title} | English Quiz`}</title>
        <meta name="description" content={description} />
      </Head>

      <Header />
      <main className={styles.main}>
        <QuizCategoryList quizCategoryList={quizCategoryList} />
        <div className={styles.mainContents}>{children}</div>
      </main>
    </>
  );
};
