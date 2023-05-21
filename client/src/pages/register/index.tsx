import { HeaderWithPage } from "@/components/templates/HeaderWithPage";
import { useAuth } from "@/hooks/user/useAuth";

const Register = () => {
  useAuth();

  return <HeaderWithPage title="登録"></HeaderWithPage>;
};

export default Register;
