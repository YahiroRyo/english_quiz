import styles from "./index.module.scss";
import { apiQuizCategoryList } from "@/modules/api/quiz/category";
import { useAuth } from "@/hooks/user/useAuth";
import Link from "next/link";
import { ROUTE_PATHNAME } from "@/constants/route";
import { useRouter } from "next/router";
import { Alert } from "@/components/molecures/Alert";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTag } from "@fortawesome/free-solid-svg-icons";
import { SmallBlackBoldText } from "@/components/atoms/Text/SmallBlackBoldText";
import { useSafePush } from "@/hooks/route/useSafePush";

export const QuizCategoryList = () => {
  const [user, setUser, isReady] = useAuth();
  const router = useRouter();
  const safePush = useSafePush();
  const { data, error, isLoading, status, mutate, retryCount, initRetryCount } =
    apiQuizCategoryList(user?.token);
  const { quizCategoryId } = router.query;

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
    <div className={styles.quizCategoryListWrapper}>
      <Alert designType="error">{error}</Alert>

      <div className={styles.quizCategoryList}>
        {data.data.map((quizCategory) => (
          <Link
            className={`${styles.quizCategoryLink} ${
              Number(quizCategoryId) == quizCategory.quizCategoryId
                ? styles.quizCategoryLinkSelected
                : ""
            }`}
            key={quizCategory.quizCategoryId}
            href={`${ROUTE_PATHNAME.QUIZ}/quizCategory?quizCategoryId=${quizCategory.quizCategoryId}`}
          >
            <SmallBlackBoldText>
              <div className={styles.quizCategoryLinkText}>
                <FontAwesomeIcon icon={faTag} />
                {quizCategory.name}
              </div>
            </SmallBlackBoldText>
          </Link>
        ))}
      </div>
    </div>
  );
};
