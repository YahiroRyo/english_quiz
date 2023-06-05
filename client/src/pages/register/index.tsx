import { RegisterForm } from "@/components/organisms/RegisterForm";
import { HeaderWithPage } from "@/components/templates/HeaderWithPage";

const Index = () => {
  return (
    <HeaderWithPage title="登録">
      <RegisterForm />
    </HeaderWithPage>
  );
};

export default Index;
