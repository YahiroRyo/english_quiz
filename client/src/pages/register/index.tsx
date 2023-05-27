import { RegisterForm } from "@/components/organisms/RegisterForm";
import { HeaderWithPage } from "@/components/templates/HeaderWithPage";
import { useAuth } from "@/hooks/user/useAuth";

const Register = () => {
  return (
    <HeaderWithPage title="登録">
      <RegisterForm />
    </HeaderWithPage>
  );
};

export default Register;
