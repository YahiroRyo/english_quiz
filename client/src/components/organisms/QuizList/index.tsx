import { Alert } from "@/components/molecures/Alert";
import { ROUTE_PATHNAME } from "@/constants/route";
import { useSafePush } from "@/hooks/route/useSafePush";
import { useAuth } from "@/hooks/user/useAuth";
import { apiQuizList } from "@/modules/api/quiz";
import { useRouter } from "next/router";
import { useState } from "react";
import styles from "./index.module.scss";
import { QuizCard } from "@/components/molecures/QuizCard";

export const QuizList = () => {
  const [user, setUser, isReady] = useAuth();
  const router = useRouter();
  const safePush = useSafePush();
  const { quizCategoryId } = router.query;
  const [currentPage, setCurrentPage] = useState(1);

  const { data, error, isLoading, status, mutate, retryCount, initRetryCount } =
    apiQuizList(Number(quizCategoryId), currentPage, user?.token!);

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
    </div>
  );
};
