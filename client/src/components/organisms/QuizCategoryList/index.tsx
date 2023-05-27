import { BorderRedButton } from "@/components/atoms/Button/BorderRedButton";
import styles from "./index.module.scss";
import { useEffect, useState } from "react";
import { apiQuizCategoryList } from "@/modules/api/quiz/category";
import { useAuth } from "@/hooks/user/useAuth";
import { QuizCategory } from "@/types/quiz";
import Link from "next/link";
import { ROUTE_PATHNAME } from "@/constants/route";
import axios from "axios";
import { useRouter } from "next/router";
import { Alert } from "@/components/molecures/Alert";
import { ErrorResponse } from "@/types/response";
import { ERROR_MESSAGE } from "@/constants/api";

export const QuizCategoryList = () => {
  const [user] = useAuth();
  const [quizCategoryList, setQuizCategoryList] = useState<QuizCategory[]>([]);
  const [error, setError] = useState<string>("");
  const router = useRouter();

  useEffect(() => {
    const main = async () => {
      if (user) {
        try {
          const res = await apiQuizCategoryList(user?.token!);
          setQuizCategoryList(res.data);
        } catch (e) {
          if (axios.isAxiosError(e)) {
            const responseData = e.response?.data as ErrorResponse;
            const status = e.response?.status;

            if (status === 401 || status === 403) {
              router.push(ROUTE_PATHNAME.LOGIN);
              return;
            }

            setError(responseData.message);
            return;
          }

          setError(ERROR_MESSAGE.UNKNOWN_ERROR);
        }
      }
    };

    main();
  }, [user]);

  return (
    <div className={styles.quizCategoryListWrapper}>
      <Alert designType="error">{error}</Alert>

      <div className={styles.quizCategoryList}>
        {quizCategoryList.map((quizCategory) => (
          <Link
            className={styles.quizCategoryLink}
            key={quizCategory.quizCategoryId}
            href={`${ROUTE_PATHNAME.QUIZ}/${quizCategory.quizCategoryId}`}
          >
            <BorderRedButton>{quizCategory.name}</BorderRedButton>
          </Link>
        ))}
      </div>
    </div>
  );
};
