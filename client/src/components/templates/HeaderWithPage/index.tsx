import { Header } from "@/components/organisms/Header";
import Head from "next/head";
import styles from "./index.module.scss";

type Props = {
  children?: React.ReactNode;
  title: string;
  description?: string;
};

export const HeaderWithPage = ({ children, title, description }: Props) => {
  const [isOpeningMenu, setIsOpeningMenu] = useState(false);

  return (
    <>
      <Head>
        <title>{`${title} | English Quiz`}</title>
        <meta name="description" content={description} />
      </Head>

      <Header
        isOpeningMenu={isOpeningMenu}
        handleClickToggleMenuButton={() => setIsOpeningMenu(!isOpeningMenu)}
      />
      <main className={styles.main}>{children}</main>
    </>
  );
};
