import ListGroupTemplate from "./ListGroupTemplate";

const ListGroups = ({ listChat }) => {
  return (
    <ul>
      {listChat.map((data, index) => {
        return <ListGroupTemplate key={index} data={data} />;
      })}
    </ul>
  );
};
export default ListGroups;
