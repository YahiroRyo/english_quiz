import { QuizCategoryList } from "@/components/organisms/QuizCategoryList";
import { HeaderWithPage } from "@/components/templates/HeaderWithPage";
import { useAuth } from "@/hooks/user/useAuth";

const Home = () => {
  useAuth();

  return (
    <HeaderWithPage title="ホーム">
      <QuizCategoryList />
    </HeaderWithPage>
  );
};

export default Home;
