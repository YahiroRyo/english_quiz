import { QuizSolutionAnalysis } from "@/components/organisms/QuizSolutionAnalysis";
import { HeaderAndQuizCategoryListWithPage } from "@/components/templates/HeaderAndQuizCategoryListWithPage";
import { apiQuizCategoryList } from "@/modules/api/quiz/category";
import { GetStaticProps, InferGetStaticPropsType } from "next";

const Index = ({
  quizCategoryJson,
}: InferGetStaticPropsType<typeof getStaticProps>) => {
  return (
    <HeaderAndQuizCategoryListWithPage
      quizCategoryList={JSON.parse(quizCategoryJson)}
      title="クイズ"
    >
      <QuizSolutionAnalysis />
    </HeaderAndQuizCategoryListWithPage>
  );
};

export const getStaticProps: GetStaticProps = async () => {
  const res = await apiQuizCategoryList();
  const quizCategoryJson = JSON.stringify(res.data);

  return { props: { quizCategoryJson } };
};

export default Index;
