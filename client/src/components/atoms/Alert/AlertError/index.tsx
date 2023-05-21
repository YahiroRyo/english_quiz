import styles from "./index.module.scss";

type Props = {
  children: React.ReactNode;
};

export const AlertError = ({ children }: Props) => {
  return <div className={styles.alert}>{children}</div>;
};
