import { Header } from "@/components/organisms/Header";
import Head from "next/head";
import styles from "./index.module.scss";
import { QuizCategoryList } from "@/components/organisms/QuizCategoryList";

type Props = {
  children?: React.ReactNode;
  title: string;
  description?: string;
};

export const HeaderAndQuizCategoryListWithPage = ({
  children,
  title,
  description,
}: Props) => {
  return (
    <>
      <Head>
        <title>{`${title} | English Quiz`}</title>
        <meta name="description" content={description} />
      </Head>

      <Header />
      <main className={styles.main}>
        <QuizCategoryList />
        <div className={styles.mainContents}>{children}</div>
      </main>
    </>
  );
};
