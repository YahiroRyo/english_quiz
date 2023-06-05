import { HeaderWithPage } from "@/components/templates/HeaderWithPage";
import { ROUTE_PATHNAME } from "@/constants/route";
import { useSafePush } from "@/hooks/route/useSafePush";
import { useAuth } from "@/hooks/user/useAuth";
import { apiLogout } from "@/modules/api/logout";
import { useEffect } from "react";

const Index = () => {
  const [user, setUser] = useAuth();
  const safePush = useSafePush();

  useEffect(() => {
    const main = async () => {
      try {
        await apiLogout(user?.token!);
      } catch (e) {}

      setUser(undefined);
      safePush(ROUTE_PATHNAME.LOGIN);
    };

    main();
  }, []);

  <HeaderWithPage title="ログアウト"></HeaderWithPage>;
};

export default Index;
