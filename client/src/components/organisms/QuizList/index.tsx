import { Alert } from "@/components/molecures/Alert";
import { ROUTE_PATHNAME } from "@/constants/route";
import { useSafePush } from "@/hooks/route/useSafePush";
import { useAuth } from "@/hooks/user/useAuth";
import { apiQuizList } from "@/modules/api/quiz";
import { useRouter } from "next/router";
import { useState } from "react";
import styles from "./index.module.scss";
import { QuizCard } from "@/components/molecures/QuizCard";
import { Pagination } from "@/components/molecures/Pagination";

export const QuizList = () => {
  const router = useRouter();
  const safePush = useSafePush();
  const [user, setUser, isReady] = useAuth();
  const { quizCategoryId } = router.query;
  const [currentPageCount, setCurrentPageCount] = useState(1);

  const onRefreshCurrentPageCount = (refreshedCurrentPageCount: number) => {
    setCurrentPageCount(refreshedCurrentPageCount);
  };

  const { data, error, isLoading, status, mutate, retryCount, initRetryCount } =
    apiQuizList(Number(quizCategoryId), currentPageCount, user?.token!);

  if (!isReady) {
    return <></>;
  }

  if (isLoading) {
    return <></>;
  }

  if (status === 401 || status == 403) {
    if (retryCount >= 5) {
      initRetryCount();
      setUser(undefined);
      safePush(ROUTE_PATHNAME.LOGIN);
      return <></>;
    }

    setTimeout(mutate, 500);
    return <></>;
  }

  initRetryCount();

  if (error) {
    return <Alert designType="error">{error}</Alert>;
  }

  if (!data) {
    return <></>;
  }

  return (
    <div className={styles.quizList}>
      {data.data.quizList.map((quiz) => (
        <QuizCard
          key={quiz.quizId}
          quizId={quiz.quizId}
          quizCategoryId={Number(quizCategoryId)}
          question={quiz.question}
          isCorrect={quiz.response?.isCorrect}
        />
      ))}
      <Pagination
        maxPageCount={data.data.maxPageCount}
        currentPageCount={currentPageCount}
        onRefreshCurrentPageCount={onRefreshCurrentPageCount}
      />
    </div>
  );
};
