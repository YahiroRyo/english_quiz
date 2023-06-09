import { BorderRedButton } from "@/components/atoms/Button/BorderRedButton";
import { Alert } from "@/components/molecures/Alert";
import { ROUTE_PATHNAME } from "@/constants/route";
import { useAuth } from "@/hooks/user/useAuth";
import { apiQuizCategory } from "@/modules/api/quiz/category/quizCategoryId";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useRouter } from "next/router";
import styles from "./index.module.scss";
import { apiCreateQuizList } from "@/modules/api/quiz";

export const CreateQuizRequestButton = () => {
  const router = useRouter();
  const [user, setUser, isReady] = useAuth();
  const { quizCategoryId } = router.query;
  const { data, error, isLoading, status, mutate, retryCount, initRetryCount } =
    apiQuizCategory(Number(quizCategoryId), user?.token);

  if (!isReady || isLoading) {
    <></>;
  }

  if (status === 401 || status == 403) {
    if (retryCount >= 5) {
      initRetryCount();
      setUser(undefined);
      router.push(ROUTE_PATHNAME.LOGIN);
      return <></>;
    }

    mutate();
    <></>;
  }

  initRetryCount();

  if (error) {
    return <Alert designType="error">{error}</Alert>;
  }

  if (!data) {
    return <></>;
  }

  const handleClickButton = async () => {
    await apiCreateQuizList(data.data.quizCategoryId, user?.token!);
  };

  return (
    <BorderRedButton onClick={handleClickButton}>
      <div className={styles.button}>
        <FontAwesomeIcon icon={faPlus} />
        {`${data.data.name}に関する問題の作成をリクエスト`}
      </div>
    </BorderRedButton>
  );
};
