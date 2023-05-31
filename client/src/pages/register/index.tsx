import { RegisterForm } from "@/components/organisms/RegisterForm";
import { HeaderWithPage } from "@/components/templates/HeaderWithPage";

const Register = () => {
  return (
    <HeaderWithPage title="登録">
      <RegisterForm />
    </HeaderWithPage>
  );
};

export default Register;
