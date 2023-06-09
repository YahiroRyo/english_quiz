import { QuizSolutionAnalysis } from "@/components/organisms/QuizSolutionAnalysis";
import { HeaderAndQuizCategoryListWithPage } from "@/components/templates/HeaderAndQuizCategoryListWithPage";

const Index = () => {
  return (
    <HeaderAndQuizCategoryListWithPage title="クイズ">
      <QuizSolutionAnalysis />
    </HeaderAndQuizCategoryListWithPage>
  );
};

export default Index;
