import styles from "./index.module.scss";

type Props = {
  children?: React.ReactNode;
};

export const MediumRedBoldText = ({ children }: Props) => {
  return <p className={styles.text}>{children}</p>;
};
