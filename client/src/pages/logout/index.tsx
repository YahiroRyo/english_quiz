import { HeaderWithPage } from "@/components/templates/HeaderWithPage";
import { ROUTE_PATHNAME } from "@/constants/route";
import { useAuth } from "@/hooks/user/useAuth";
import { apiLogout } from "@/modules/api/logout";
import { useRouter } from "next/router";
import { useEffect } from "react";

const Logout = () => {
  const router = useRouter();
  const [user, setUser] = useAuth();

  useEffect(() => {
    const main = async () => {
      try {
        await apiLogout(user?.token!);
      } catch (e) {}

      setUser(undefined);
      router.push(ROUTE_PATHNAME.LOGIN);
    };

    main();
  }, []);

  <HeaderWithPage title="ログアウト"></HeaderWithPage>;
};

export default Logout;
