import { HeaderAndQuizCategoryListWithPage } from "@/components/templates/HeaderAndQuizCategoryListWithPage";
import { apiQuizCategoryList } from "@/modules/api/quiz/category";
import { GetStaticProps, InferGetStaticPropsType } from "next";

const Home = ({
  quizCategoryJson,
}: InferGetStaticPropsType<typeof getStaticProps>) => {
  return (
    <HeaderAndQuizCategoryListWithPage
      quizCategoryList={JSON.parse(quizCategoryJson)}
      title="ホーム"
    >
      おはようございます！今日も一日頑張ろう！
    </HeaderAndQuizCategoryListWithPage>
  );
};

export const getStaticProps: GetStaticProps = async () => {
  const res = await apiQuizCategoryList();
  const quizCategoryJson = JSON.stringify(res.data);

  return { props: { quizCategoryJson } };
};

export default Home;
