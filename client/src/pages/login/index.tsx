import { LoginForm } from "@/components/organisms/LoginForm";
import { HeaderWithPage } from "@/components/templates/HeaderWithPage";
import { useAuth } from "@/hooks/user/useAuth";

const Login = () => {
  useAuth();

  return (
    <HeaderWithPage title="ログイン">
      <LoginForm />
    </HeaderWithPage>
  );
};

export default Login;
