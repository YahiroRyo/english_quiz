import { Alert } from "@/components/molecures/Alert";
import { CreateQuizRequestButton } from "@/components/organisms/CreateQuizRequestButton";
import { HeaderAndQuizCategoryListWithPage } from "@/components/templates/HeaderAndQuizCategoryListWithPage";
import { ROUTE_PATHNAME } from "@/constants/route";
import { useSafePush } from "@/hooks/route/useSafePush";
import { useAuth } from "@/hooks/user/useAuth";
import { apiQuizCategory } from "@/modules/api/quiz/category/quizCategoryId";
import { useRouter } from "next/router";
import { useState } from "react";

const Index = () => {
  const router = useRouter();
  const safePush = useSafePush();
  const [user, setUser, isReady] = useAuth();
  const { quizCategoryId } = router.query;
  const [retryCount, setRetryCount] = useState(0);

  const { data, error, isLoading, status, mutate } = apiQuizCategory(
    Number(quizCategoryId),
    user?.token
  );

  if (!isReady || isLoading) {
    <HeaderAndQuizCategoryListWithPage title="ロード中"></HeaderAndQuizCategoryListWithPage>;
  }

  if (status === 401 || status == 403) {
    if (retryCount >= 5) {
      setUser(undefined);
      safePush(ROUTE_PATHNAME.LOGIN);
      return (
        <HeaderAndQuizCategoryListWithPage title="ロード中"></HeaderAndQuizCategoryListWithPage>
      );
    }

    mutate();
    setRetryCount((count) => count + 1);
    <HeaderAndQuizCategoryListWithPage title=""></HeaderAndQuizCategoryListWithPage>;
  }

  if (error) {
    return (
      <HeaderAndQuizCategoryListWithPage title="エラー">
        <Alert designType="error">{error}</Alert>
      </HeaderAndQuizCategoryListWithPage>
    );
  }

  if (!data) {
    return <></>;
  }

  return (
    <HeaderAndQuizCategoryListWithPage title={`${data?.data.name}の勉強`}>
      <CreateQuizRequestButton />
    </HeaderAndQuizCategoryListWithPage>
  );
};

export default Index;
