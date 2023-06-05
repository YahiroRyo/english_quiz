import styles from "./index.module.scss";

type Props = {
  children?: React.ReactNode;
};

export const LergeDarkBoldText = ({ children }: Props) => {
  return <div className={styles.text}>{children}</div>;
};
