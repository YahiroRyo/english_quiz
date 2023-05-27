import { LoginForm } from "@/components/organisms/LoginForm";
import { HeaderWithPage } from "@/components/templates/HeaderWithPage";

const Login = () => {
  return (
    <HeaderWithPage title="ログイン">
      <LoginForm />
    </HeaderWithPage>
  );
};

export default Login;
