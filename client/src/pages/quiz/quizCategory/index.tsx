import { Alert } from "@/components/molecures/Alert";
import { CreateQuizRequestButton } from "@/components/organisms/CreateQuizRequestButton";
import { QuizList } from "@/components/organisms/QuizList";
import { HeaderAndQuizCategoryListWithPage } from "@/components/templates/HeaderAndQuizCategoryListWithPage";
import { apiQuizCategoryList } from "@/modules/api/quiz/category";
import { apiQuizCategory } from "@/modules/api/quiz/category/quizCategoryId";
import { GetStaticProps, InferGetStaticPropsType } from "next";
import { useRouter } from "next/router";

const Index = ({
  quizCategoryJson,
}: InferGetStaticPropsType<typeof getStaticProps>) => {
  const router = useRouter();
  const { quizCategoryId } = router.query;

  const { data, error, isLoading, initRetryCount } = apiQuizCategory(
    Number(quizCategoryId)
  );

  if (isLoading) {
    <HeaderAndQuizCategoryListWithPage
      quizCategoryList={JSON.parse(quizCategoryJson)}
      title="ロード中"
    ></HeaderAndQuizCategoryListWithPage>;
  }

  if (error) {
    return (
      <HeaderAndQuizCategoryListWithPage
        quizCategoryList={JSON.parse(quizCategoryJson)}
        title="エラー"
      >
        <Alert designType="error">{error}</Alert>
      </HeaderAndQuizCategoryListWithPage>
    );
  }

  if (!data) {
    return (
      <HeaderAndQuizCategoryListWithPage
        quizCategoryList={JSON.parse(quizCategoryJson)}
        title="データが存在しません"
      ></HeaderAndQuizCategoryListWithPage>
    );
  }
  initRetryCount();

  return (
    <HeaderAndQuizCategoryListWithPage
      quizCategoryList={JSON.parse(quizCategoryJson)}
      title={`${data.data.name}の勉強`}
    >
      <CreateQuizRequestButton />
      <QuizList />
    </HeaderAndQuizCategoryListWithPage>
  );
};

export const getStaticProps: GetStaticProps = async () => {
  const res = await apiQuizCategoryList();
  const quizCategoryJson = JSON.stringify(res.data);

  return { props: { quizCategoryJson } };
};

export default Index;
