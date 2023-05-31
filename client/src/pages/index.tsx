import { HeaderAndQuizCategoryListWithPage } from "@/components/templates/HeaderAndQuizCategoryListWithPage";
import { useAuth } from "@/hooks/user/useAuth";

const Home = () => {
  useAuth();

  return (
    <HeaderAndQuizCategoryListWithPage title="ホーム">
      おはようございます！今日も一日頑張ろう！
    </HeaderAndQuizCategoryListWithPage>
  );
};

export default Home;
