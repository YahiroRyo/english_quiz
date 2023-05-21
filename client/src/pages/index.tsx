import { HeaderWithPage } from "@/components/templates/HeaderWithPage";
import { useAuth } from "@/hooks/user/useAuth";

const Home = () => {
  useAuth();

  return <HeaderWithPage title="ホーム"></HeaderWithPage>;
};

export default Home;
