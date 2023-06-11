import styles from "./index.module.scss";

type Props = {
  maxPageCount: number;
  currentPageCount: number;
  onRefreshCurrentPageCount: (currentPageCount: number) => void;
};

export const Pagination = ({
  maxPageCount,
  currentPageCount,
  onRefreshCurrentPageCount,
}: Props) => {
  const MAX_BUTTON_COUNT = 5;
  const MIN_PAGE_COUNT = 1;

  const isMaxPageCountLessThenMaxButtonCount = () => {
    return maxPageCount < MAX_BUTTON_COUNT;
  };

  const minCount = () => {
    if (currentPageCount - Math.round(MAX_BUTTON_COUNT / 2) < MIN_PAGE_COUNT) {
      return MIN_PAGE_COUNT;
    }

    if (currentPageCount + Math.floor(MAX_BUTTON_COUNT / 2) >= maxPageCount) {
      return maxPageCount - MAX_BUTTON_COUNT + 1;
    }

    return currentPageCount - Math.floor(MAX_BUTTON_COUNT / 2);
  };

  const maxCount = () => {
    if (currentPageCount + Math.floor(MAX_BUTTON_COUNT / 2) > maxPageCount) {
      return maxPageCount;
    }

    if (currentPageCount - Math.floor(MAX_BUTTON_COUNT / 2) <= MIN_PAGE_COUNT) {
      return MAX_BUTTON_COUNT;
    }

    return currentPageCount + Math.floor(MAX_BUTTON_COUNT / 2);
  };

  const PaginationButtonListByCount = ({ count }: { count: number }) => {
    return (
      <>
        {new Array(count).fill(undefined).map((_, index) => (
          <button
            key={index}
            onClick={() => onRefreshCurrentPageCount(index + 1)}
            className={
              currentPageCount === index + 1
                ? styles.paginationButtonSelected
                : styles.paginationButton
            }
          >
            {index + 1}
          </button>
        ))}
      </>
    );
  };

  const PaginationButtonListByMinCountAndMaxCount = ({
    minCount,
    maxCount,
  }: {
    minCount: number;
    maxCount: number;
  }) => {
    return (
      <>
        {new Array(maxCount - minCount + 1).fill(undefined).map((_, index) => (
          <button
            key={index}
            onClick={() => onRefreshCurrentPageCount(minCount + index)}
            className={
              currentPageCount === minCount + index
                ? styles.paginationButtonSelected
                : styles.paginationButton
            }
          >
            {minCount + index}
          </button>
        ))}
      </>
    );
  };

  return (
    <div className={styles.pagination}>
      {isMaxPageCountLessThenMaxButtonCount() ? (
        <PaginationButtonListByCount count={maxPageCount} />
      ) : (
        <PaginationButtonListByMinCountAndMaxCount
          minCount={minCount()}
          maxCount={maxCount()}
        />
      )}
    </div>
  );
};
