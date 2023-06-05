import { faQ } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import styles from "./index.module.scss";

export const QuestionIcon = () => {
  return (
    <div className={styles.icon}>
      <FontAwesomeIcon icon={faQ} />
    </div>
  );
};
